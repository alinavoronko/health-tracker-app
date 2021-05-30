using System;
using System.Collections.Generic;

namespace MarathonService.Models
{
  public class Marathon : BaseEntity
  {
    public DateTime StartDate { get; set; }
    public float Goal { get; set; }
    public long CreatorId { get; set; }

    public ICollection<MarathonParticipant> Participants { get; set; }
  }
}
