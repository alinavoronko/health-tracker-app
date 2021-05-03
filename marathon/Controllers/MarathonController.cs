using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using MarathonService.Database.Context;
using MarathonService.Models;

namespace MarathonService.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class MarathonController : ControllerBase
    {
        private readonly MarathonContext _context;

        public MarathonController(MarathonContext context)
        {
            _context = context;
        }

        // GET: api/Marathon
        [HttpGet]
        public async Task<ActionResult<IEnumerable<Marathon>>> GetMarathons()
        {
            return await _context.Marathons.ToListAsync();
        }

        // GET: api/Marathon/5
        [HttpGet("{id}")]
        public async Task<ActionResult<Marathon>> GetMarathon(long id)
        {
            var marathon = await _context.Marathons.FindAsync(id);

            if (marathon == null)
            {
                return NotFound();
            }

            return marathon;
        }

        // PUT: api/Marathon/5
        // To protect from overposting attacks, see https://go.microsoft.com/fwlink/?linkid=2123754
        [HttpPut("{id}")]
        public async Task<IActionResult> PutMarathon(long id, Marathon marathon)
        {
            if (id != marathon.Id)
            {
                return BadRequest();
            }

            _context.Entry(marathon).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!MarathonExists(id))
                {
                    return NotFound();
                }
                else
                {
                    throw;
                }
            }

            return NoContent();
        }

        // POST: api/Marathon
        // To protect from overposting attacks, see https://go.microsoft.com/fwlink/?linkid=2123754
        [HttpPost]
        public async Task<ActionResult<Marathon>> PostMarathon(Marathon marathon)
        {
            _context.Marathons.Add(marathon);
            await _context.SaveChangesAsync();

            return CreatedAtAction("GetMarathon", new { id = marathon.Id }, marathon);
        }

        // DELETE: api/Marathon/5
        [HttpDelete("{id}")]
        public async Task<IActionResult> DeleteMarathon(long id)
        {
            var marathon = await _context.Marathons.FindAsync(id);
            if (marathon == null)
            {
                return NotFound();
            }

            _context.Marathons.Remove(marathon);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        private bool MarathonExists(long id)
        {
            return _context.Marathons.Any(e => e.Id == id);
        }
    }
}
